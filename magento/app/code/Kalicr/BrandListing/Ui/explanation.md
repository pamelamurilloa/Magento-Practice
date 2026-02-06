# Folder Guide

## UI
The folder in which to put all things related to the user interface, such as layout XML files, UI component XML files, templates, and related view files.
This does not include frontend or adminhtml specific files, which should go in their respective folders.

## Components
This folder contains UI components, which are reusable building blocks for creating user interfaces in Magento 2.
UI components are defined using XML and can include grids, forms, buttons, and other interactive elements.

## Listing
This subfolder is specifically for UI components related to listings, such as grids or tables that display collections of data.
In other cases, like forms, we need a "Form" subfolder instead.
More cases include:
 - "Modal" for modal dialogs
 - "Wizard" for multi-step processes
 - "Tabs" for tabbed interfaces
 - "Filters" for filter components
 - "Tree" for hierarchical data representations
 - "Chart" for graphical data representations
 - "Dashboard" for dashboard interfaces
 - "Menu" for menu components
 - "Toolbar" for toolbar components
 - "Gallery" for image or media galleries
 - "Calendar" for calendar or scheduling components
 - "Slider" for slider components
 - "Accordion" for accordion-style interfaces
 - "Map" for map-based components
 - "Notification" for notification components
 - "Search" for search interface components
 - "Profile" for user profile interfaces
 - "Review" for review or feedback components
 - "Comparison" for comparison interfaces
 etc...

## Column
This subfolder controlls specifically a single vertical column within a listing grid.

## BrandActions
Finally, this file defines the actions available for each brand in the listing grid, such as edit or delete actions.
We put it here because it is specifically related to the columns of the listing grid, as it defines actions that can be performed on each row (brand) in the grid.

__Overall, this is the same style that the Magento core uses for its own modules.__
