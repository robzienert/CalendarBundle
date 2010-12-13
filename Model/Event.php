<?php

namespace Bundle\CalendarBundle\Model;

abstract class Event
{
    protected $id;

    protected $category;
    
    protected $calendar;

    protected $title;

    protected $description;

    protected $expression;
}