<?php

namespace Seacommerce\MapperBundle\EventListener;

use ReflectionClass;
use Seacommerce\Mapper\Events\PostResolveEvent;
use Seacommerce\Mapper\MapperEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DoctrineProxyEventSubscriber implements EventSubscriberInterface
{
    private $proxyNamespace = 'Proxies';

    public static function getSubscribedEvents()
    {
        return [
            MapperEvents::POST_RESOLVE => [
                ['postResolve', 0]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getProxyNamespace(): string
    {
        return $this->proxyNamespace;
    }

    /**
     * @param string $proxyNamespace
     */
    public function setProxyNamespace(string $proxyNamespace): void
    {
        $this->proxyNamespace = $proxyNamespace;
    }

    public function postResolve(PostResolveEvent $event)
    {
        $prefix = $this->proxyNamespace . '\\__CG__\\';
        $len = strlen($prefix);
        if (substr($event->getSourceClass(), 0, $len) === $prefix) {
            $event->setSourceClass($this->getEntityFromProxy($event->getSourceClass()));
        }
        if (substr($event->getTargetClass(), 0, $len) === $prefix) {
            $event->setTargetClass($this->getEntityFromProxy($event->getTargetClass()));
        }
    }

    private function getEntityFromProxy(string $proxyClass): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $refClass = new ReflectionClass($proxyClass);
        $parent = $refClass->getParentClass();
        if ($parent) {
            return $parent->getName();
        }
        return $proxyClass;
    }
}