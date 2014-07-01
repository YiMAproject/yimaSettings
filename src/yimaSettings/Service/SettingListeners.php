<?php
namespace yimaSettings\Service;

use Poirot\Dataset\Entity;
use yimaLocali\Detector\AggregateDetectorInterface;
use yimaLocali\Detector\DetectorInterface;
use yimaLocali\Detector\Feature\SystemWideInterface;
use yimaLocali\LocaleEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;

/**
 * Class SettingListeners
 *
 * @package yimaSettings\Service
 */
class SettingListeners implements SharedListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach to an event manager
     *
     * @param  SharedEventManagerInterface $events
     * @param  integer $priority
     */
    public function attachShared(SharedEventManagerInterface $events, $priority = 1000000)
    {
        // attach Bootstrap MVC Event to detect locale
        $events->attach(
            'Zend\Mvc\Application',
            MvcEvent::EVENT_BOOTSTRAP,
            array($this, 'mergeWithConfig'),
            $priority
        );
    }

    /**
     * Merge Settings with application merged config
     *
     * @param MvcEvent $mvcEvent
     */
    public function mergeWithConfig(MvcEvent $mvcEvent)
    {
        /** @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $mvcEvent->getApplication()->getServiceManager();

        $config = $sm->get('config');
        if (isset($config['yima-settings'])
            && is_array($config['yima-settings'])
            && !empty($config['yima-settings'])
        ) {
            /** @var $yimaSettings Settings */
            $yimaSettings = $sm->get('yimaSettings');

            // iterate over values of each settings namespace
            foreach($yimaSettings->getSetting('general') as $key => $entity) {
                if (isset($entity->options) && $entity->options->merged_config) {
                    $value = $entity->value;
                    if ($value instanceof Entity) {
                        $value = $value->getArrayCopy();
                    } elseif (is_object($value) && method_exists($value, 'toArray')) {
                        $value = $value->toArray();
                    }

                    if (is_array($value)) {
                        $config = ArrayUtils::merge($config, $value);
                    } else {
                        throw new \Exception(
                            sprintf(
                                'Settings value "%s" mark as merged config but "%s" given.'
                                ,$key
                                ,(is_object($value)) ? get_class($value) : gettype($value)
                            )
                        );
                    }
                }
            }

            // merge settings with application config
            $sm->setAllowOverride(true);
            $sm->setService('config', $config);
            $sm->setAllowOverride(false);
        }
    }

    /**
     * Detach all our listeners from the event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detachShared(SharedEventManagerInterface $events)
    {

    }
}
