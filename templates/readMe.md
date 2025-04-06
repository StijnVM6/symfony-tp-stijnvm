# Symfony TP Stijn Vande Maele

## Installation

```
composer run-script setup && symfony server:start
```

## Relationships:

Many-to-one:
A `classGroup` has many `student`s, but a `student` has only one `classGroup`.
Many-to-many:
A `project` can have many `student`s and a `student` can have many `project`s.

## Navigation:

Homepage has a link to:

-   class groups
-   students -> shows list of all students with pagination
-   projects
-   users
-   login && register OR logout

## Notes:

-   All CRUD operations are completed.
-   Pagination added for students.
-   Clicking on `id` will redirect to GET by Id details page.
-   Edit and Delete buttons added.
-   Login for Assert rights.
-   Logout and register available on homepage.
