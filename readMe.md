# Symfony TP Stijn Vande Maele

## Installation

```
composer run-script setup && symfony server:start
```

This will execute:

```
"setup": [
    "composer install",
    "php bin/console doctrine:database:drop --force",
    "php bin/console doctrine:database:create",
    "php bin/console doctrine:migrations:migrate --no-interaction",
    "php bin/console doctrine:fixtures:load --no-interaction"
]
```

## Relationships:

Many-to-one:</br>
A `classGroup` has many `student`s, but a `student` has only one `classGroup`.</br>
Many-to-many:</br>
A `project` can have many `student`s and a `student` can have many `project`s.

## Navigation:

Homepage has a link to:

-   class groups
-   students -> shows list of all students with pagination
-   projects
-   users
-   (login && register) OR (logout)

## Notes:

-   All CRUD operations are completed.
-   Pagination added for students.
-   Clicking on `id` will redirect to GET-by-id details page.
-   Edit and Delete options available.
-   Login for Assert rights.
-   Logout and register available on homepage.
