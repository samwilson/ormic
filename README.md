ItemDB
======

A strange thing indeed. Please ignore for now.

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `config.dist.php` to `config.php` and edit that
4. Copy `modules/database/config/database.php` to `application/config/database.php` and edit that
5. Set up URL rewriting (see below)
6. Run `php index.php upgrade`

### Example .htaccess for Apache

	RewriteEngine On
	RewriteRule ^(?:modules|application|vendor)\b.* index.php/$0 [L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule .* index.php/$0 [PT]

## Conventions

Database tables for 'through' many-to-many relationships:
* only have two columns,
* don't have model classes,
* have `_2_` in their name.
