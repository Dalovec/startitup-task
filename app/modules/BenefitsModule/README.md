# Benefits Module

----
## Description

This module is used to add benefits to the application. Benefits are used to give users a discount on a product or service.

## Current Limitations

- Translations for templates are not implemented.
- The module is not tested (No tests are available).
- No translations for benefit content are available.
- Users can only claim one benefit at a time.
- If a benefit is deleted from the database, it is not removed from the user's benefits list (they cannot claim another one).

## Implemented widgets

### UserBenefitsListing

This widget is used to display the benefit that the user has claimed.
An admin can remove the benefit from the user's list.
