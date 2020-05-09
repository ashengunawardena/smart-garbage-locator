## Smart Garbage Locator

## Table of Content

* [Project Scenario](https://github.com/ashengunawardena/smart-garbage-locator#project-scenario)
* [Functional Requirements](https://github.com/ashengunawardena/smart-garbage-locator#functional-requirements)
* [Directory Structure](https://github.com/ashengunawardena/smart-garbage-locator#directory-structure)
* [User Interfaces](https://github.com/ashengunawardena/smart-garbage-locator#user-interfaces)
* [Technology Stack](https://github.com/ashengunawardena/smart-garbage-locator#technology-stack)

### Project Scenario

Colombo Municipal Council (CMC) is planning to launch a web site to optimize
garbage collection, where volunteers within district can report thrown away garbage
and garbage trucks can collect them.

* The registered members of the Green Task Force (GTF) understood here as the
volunteers, can take picture(s) of thrown away garbage, explain the impact such
as attracting wild life, terrible smell, etc., set the location, and report this incident.

* CMC has a dedicated Green Captain, a manager who can view all the reported
incidents, validate by looking at the uploaded photo(s), and approve or reject stating
how soon the garbage should be cleared.

* Garbage collection staff can see the approved reports with a summary on a Map
along with the importance (set by the captain).

* General public can see the garbage collection spots on a map and news articles
posted by the CMS.

### Functional Requirements

* There are five roles: admin, captain, volunteer, staff, and public.

* There should be an “Administrator” who can create accounts for the captain
and collecting staff.

* Admin can also post articles to improve public awareness about garbage
collection and add garbage spots.

* GTF members can signup for free. Registered GTF members can input data
(including images), delete and update his/her own incidents.

* Green captain can see the reported incidents as a list and on a map, click to
reveal more details on a popup dialog box (similar interface like Figure 1).
S/he can then approve/refuse them and set a flag based on importance such
as red flag for immediate cleanup.

* Collecting staff can see the approved reports. Different flagged reports are
displayed with different icons on a map. More information can be seen when
such icon is clicked.

* General public can see the news articles and garbage spots on a map.

### Directory Structure

```
├───database-backup                         # Database backup
│   └───sgl.sql
├───p                                       # Pages of this website
│   ├───approved-reports
│   │   ├───approved_reports.css
│   │   └───index.php 
│   ├───articles
│   │   ├───articles.css
│   │   └───index.php 
│   ├───garbage-locations
│   │   ├───garbage_locations.css
│   │   └───index.php 
│   ├───incidents
│   │   ├───incidents.css
│   │   └───index.php 
│   ├───reports
│   │   ├───reports.css
│   │   └───index.php 
│   ├───sign-in
│   │   ├───sign_in.css
│   │   └───index.php 
│   └───user-accounts
│       ├───user_accounts.css
│       └───index.php 
├───php                                     # PHP classes used to provide functionality of the website                           
│   │───dependencies                        # PHP dependancies used by below php scripts
│   ├───mail.php                            # Provides E-mail functionality
│   └───redirect_user.php                   # Processes user requests and redirects user to correct web page
│───resources                               # Resources used by the website
│   ├───css
│   │   └───fonts.css                       # Defines custom fonts using font files in below 'fonts' directory
│   ├───fonts                               # Stores custom font files
│   └───images                              # Stores images used by User Interfaces of the website
│       └───garbage_locations               # Stores user uploaded images of garbage locations
├───home.css
└───index.php                               # Main entry point to the website ('Home' Webpage)
```

### User Interfaces

#### Home - Page

![Home - Page](https://user-images.githubusercontent.com/58177462/81407466-13e34600-9159-11ea-9e43-57ce7a04c942.png)

#### Sign In - Page

![Sign In - Page](https://user-images.githubusercontent.com/58177462/81408113-46da0980-915a-11ea-925d-b49e204b8dd9.png)

#### Reports (New Report) - Page

![Reports (New Report) - Page](https://user-images.githubusercontent.com/58177462/81408367-bbad4380-915a-11ea-9ea7-6cbd653aae6f.png)

#### Reports (My Reports) - Page

![#### Reports (My Reports) - Page](https://user-images.githubusercontent.com/58177462/81408519-016a0c00-915b-11ea-84f6-ba035b61d6b5.png)

#### Reported Incidents - Page

![Reported Incidents - Page](https://user-images.githubusercontent.com/58177462/81408505-f9aa6780-915a-11ea-8194-fd6f41f9e5fe.png)

#### Reported Incidents (Garbage Location on Map) - View

![Reported Incidents (Garbage Location on Map) - View](https://user-images.githubusercontent.com/58177462/81408512-fd3dee80-915a-11ea-8d7e-81fcd15e5c03.png)

#### User Accounts - Page

![User Accounts - Page](https://user-images.githubusercontent.com/58177462/81408528-062ec000-915b-11ea-92fc-b3503e4c4206.png)

#### Approved Reports - Page

![Approved Reports - Page](https://user-images.githubusercontent.com/58177462/81408538-07f88380-915b-11ea-8f8a-f73dd2475cbd.png)

#### Articles (View for Admin Users) - Page

![Articles (View for Admin Users) - Page](https://user-images.githubusercontent.com/58177462/81408548-0b8c0a80-915b-11ea-912d-3a2098018305.png)

#### Articles (View for Non-Admin Users) - Page

![Articles (View for Non-Admin Users) - Page](https://user-images.githubusercontent.com/58177462/81408553-0e86fb00-915b-11ea-8515-2737597d3dbf.png)

#### Garbage Locations - Page

![Garbage Locations - Page](https://user-images.githubusercontent.com/58177462/81408558-1181eb80-915b-11ea-98de-34d34eb77cd4.png)
 
### Technology Stack

#### Front-End Languages

* HTML
* CSS
* JS - Used for user interaction and client side validation.

#### Back-End Languages

* PHP

#### External Libraries

* PHPMailer - Used for sending emails.

#### External APIs

* Google Sign-In API - Used to integrate Google Sign-in functionality to the website.
* Google Maps API - Used to integrate Google Maps to the website to display garbage locations.

#### Database

* MySQL


## THE END