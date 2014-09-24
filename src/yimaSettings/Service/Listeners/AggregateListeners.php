<?php
namespace yimaSettings\Service\Listeners;

use Poirot\Dataset\Entity;
use yimaSettings\DataStore\DataStoreAbstract;
use yimaSettings\DataStore\Entity\Converter\ArrayConverter;
use yimaSettings\Service\Settings;
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
class AggregateListeners implements SharedListenerAggregateInterface
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

        /** @var $yimaSettings DataStoreAbstract */
        $yimaSettings = $sm->get('yimaSettings');

        $generalCollection = $yimaSettings->using('general');
        if (! $generalCollection->getOption('merged_config'))
            // no need to merge with config
            return;

        $config = $sm->get('config');
        $generalSetting = $generalCollection->fetch();
        $generalAsConf  = $generalSetting->getAs(new ArrayConverter());

        $config = ArrayUtils::merge($config, $generalAsConf);

        // merge settings with application config
        $sm->setAllowOverride(true);
        $sm->setService('config', $config);
        $sm->setAllowOverride(false);
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
