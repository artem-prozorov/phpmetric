<?php

namespace Bizprofi\Monitoring\Traits;

trait Observerable
{
    /**
     * @var \SplObjectStorage
     */
    private $observers;

    /**
     * initObservers
     *
     * @return void
     */
    public function initObservers()
    {
        $this->observers = new \SplObjectStorage();
    }

    /**
     * attach
     *
     * @param \SplObserver $observer
     * @return void
     */
    public function attach(\SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    /**
     * detach
     *
     * @param \SplObserver $observer
     * @return void
     */
    public function detach(\SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
    {
        /** @var \SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
