The Amsys module system
=======================

* Each module is completely contained within a directory in this `modules`
  directory.
* The module is identified by its name, in `alllowercase` and `AllCamelCaps`
  forms.
* The structure of each module directory mirrors that of the top-level
  application, with `modules/modname/Providers/ModNameServiceProvider.php` being
  the only file that is *required*.
