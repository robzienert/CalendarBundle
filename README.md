CalendarBundle
==============

**This bundle is no longer maintained by myself. If you would like to take
it over, please send me a message!**

Provides applications with an events calendar. This bundle's model layer
represents a heavy port of Apple's iCal application.

*WARNING*: This is a prototype and not a final/stable bundle.

Features
--------

- Multiple Calendars
- Flexible Events
- Fully-implemented event recursion
- Event alarms
- Event RSVPs

Install
-------

Proceed with a normal bundle installation, and then execute the following steps:

Add to your config.yml:

    # app/config/config.yml
    rizza_calendar: ~

Add to your routing.yml:

    # app/config/routing.yml
    rizza_calendar_calendar:
      resource: "@RizzaCalendarBundle/Resources/config/routing/calendar.yml"
      prefix: /calendar
      
    rizza_calendar_event:
      resource: "@RizzaCalendarBundle/Resources/config/routing/event.yml"
      prefix: /event

TODO
----

- Add support for different view engines
- Commands
- Alternative storage backaends (Google Calendar, iCal feeds, etc.)
- Event hooks
- Convert event categories to labels?
