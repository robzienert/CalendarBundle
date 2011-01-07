Provides calendar and event persistence for your Symfony2 Project.

Features
========

- Compatible with Doctrine ORM ***and*** ODM thanks to a generic repository
- Model is extensible at will
- Flexible expression language for creating schedules
- Unit tested and functionally tested

Installation
============

Add CalendarBundle to your src/Bundle dir
-----------------------------------------

::

    $ git submodule add git://github.com/robzienert/CalendarBundle.git src/Bundle/CalendarBundle

Add CalendarBundle to your application kernel
---------------------------------------------

::

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new Bundle\CalendarBundle\CalendarBundle(),
            // ...
        );
    }

Changing default class mappings
-------------------------------

In case you want to change some of the default mappings, like for example
the Event class ``id`` generator strategy, one must simply replicate the default
file inside an Application Bundle then apply the necessary changes:

    cp src/Bundle/CalendarBundle/Resources/config/doctrine/metadata/orm/Bundle.CalendarBundle.Entity.Event.dcm.xml src/Application/..

Configure your project
----------------------

Include the CalendarBundle in your Doctrine mapping configuration:

    # app/config/config.yml
    doctrine.orm:
        mappings:
            CalendarBundle: ~
            # your other bundles

The above example assumes an ORM configuration, but the `mappings` configuration
block would be the same for MongoDB ODM.

Choose ORM or ODM database driver
---------------------------------

At a minimum, your configuration must define your DB driver ("orm" or "odm").

ORM
---

In YAML:

::

    # app/config/config.yml
    calendar.config:
        db_driver: orm

Or if you prefer XML:

::

    # app/config/config.xml

    <calendar:config db_driver="orm" />
