# About

Comments Pluggable System provides simple scratch for developing own comments system.
Class Form extends EventManager, loads predefined settings from db:
 - events with bound observers
 - smileys set for content filtering

You can also attach custom observers, that have an influence on Form context.

# System requirements
Tested on PHP-5.6, MariaDB-10.0.16

# Setup

1. Apply schema.sql to database (be careful to avoid table names conflict - table prefixes has not been provided yet).
2. Run "composer install" if you want to run unit tests or "composer dumpautoload".

Read use-case client in the directory of the same name.
