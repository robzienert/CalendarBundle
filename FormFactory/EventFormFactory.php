<?php

namespace Rizza\CalendarBundle\FormFactory;

use Symfony\Component\Form\FormFactoryInterface;

class EventFormFactory implements EventFormFactoryInterface
{

    protected $formFactory;
    protected $type;
    protected $name;

    public function __construct(FormFactoryInterface $formFactory, $type, $name)
    {
        $this->formFactory = $formFactory;
        $this->type = $type;
        $this->name = $name;
    }

    public function createForm($data = null)
    {
        return $this->formFactory->createNamed($this->type, $this->name, $data);
    }

}
