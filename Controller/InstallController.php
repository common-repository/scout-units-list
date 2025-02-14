<?php

namespace ScoutUnitsList\Controller;

use Exception;
use ScoutUnitsList\Manager\MigrationManager;

/**
 * Install controller
 */
class InstallController extends Controller
{
    /** @var array */
    private $rewriteRules = [];

    /**
     * Activate
     */
    public function activate()
    {
        if (version_compare(PHP_VERSION, '5.6.0', '<')) {
            return $this->error('PHP version 5.6 or higher is required to properly activate and work of this plugin.');
        }

        try {
            $this->get('manager.migration')
                ->migrate();
            $this->get('manager.config')
                ->save();

            foreach ($this->rewriteRules as $rewriteRule) {
                \add_rewrite_rule($rewriteRule['regExp'], $rewriteRule['redirect'], $rewriteRule['after']);
            }
            \flush_rewrite_rules(false);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Deactivate
     */
    public function deactivate()
    {
        \add_filter('rewrite_rules_array', function (array $rules) {
            foreach ($this->rewriteRules as $rewriteRule) {
                $regExp = $rewriteRule['regExp'];
                if (array_key_exists($regExp, $rules)) {
                    unset($rules[$regExp]);
                }
            }

            return $rules;
        });
        \flush_rewrite_rules(false);
    }

    /**
     * Uninstall
     */
    public function uninstall()
    {
        try {
            $this->get('manager.migration')
                ->migrate(MigrationManager::VERSION_EMPTY);
            $this->get('manager.config')
                ->remove();
        } catch (Exception $e) {
            return $this->error(sprintf('%s Please try to uninstall plugin again or remove options and tables ' .
                'manually from database.', $e->getMessage()));
        }
    }

    /**
     * Add rewrite rule
     *
     * @param string $regExp   regular expression
     * @param string $redirect redirect
     * @param string $after    after
     *
     * @return self
     */
    public function addRewriteRule($regExp, $redirect, $after = 'top')
    {
        $this->rewriteRules[] = [
            'after' => $after,
            'redirect' => $redirect,
            'regExp' => $regExp,
        ];
        \add_action('init', function () use ($regExp, $redirect, $after) {
            \add_rewrite_rule($regExp, $redirect, $after);
        });

        return $this;
    }

    /**
     * Error
     *
     * @param string $message message
     */
    private function error($message)
    {
        $pluginName = $this->loader->getName();
        if (is_plugin_active($pluginName)) {
            deactivate_plugins($pluginName);
        }
        wp_die($message);
    }
}
