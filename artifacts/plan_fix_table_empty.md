# Plan: Fix Empty Table in Corps-Enseignant.php

## Objective
Fix the display of teachers in the `Corps-Enseignant.php` table, as no data is currently rendering.

## Issues Identified
1. The `foreach` loop sets the item variable to `$resultat` (`foreach($result as $resultat)`), but the table cells incorrectly reference `$result['last_name']`, `$result['first_name']`, `$result['name']`, and `$result['hours_count']`.
2. The SQL query at the beginning of the file `SELECT instructor.id, user.last_name, user.first_name, user.email ...` successfully queries joined tables but misses retrieving the module name (`module.name`) and the number of hours (`hours_count`) that the frontend expects.

## Proposed Changes
1. Update the bindings inside the `foreach` loop to use `$resultat` instead of `$result`.
2. Update the SQL query in `Corps-Enseignant.php` to include `module.name` and `instructor_module.hours_count` or equivalent field according to the database schema.
3. Apply the changes safely.

## User Confirmation
Do you agree with this plan? Once confirmed, I'll apply the patch.
