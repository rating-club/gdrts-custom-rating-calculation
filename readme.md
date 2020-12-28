# GD Rating System Pro: Custom Rating Calculation

This is a demo plugin showing how to add a custom rating value (other than just average rating) and use it for ordering
and display.

## How it works?

This addon registers new calculation method/value: **crcalc** for Stars Rating method. The addon has two main files: `addon.php` and `calc.php`. Addon file includes main addon class that hooks into various areas of the GD Rating System Pro plugin, all related to the Stars Rating method. All used filters and actions include comment about their purpose.

Calc file contains the function used to actually perform the calculation for the rating item to get the rating for our custom calculation. This function includes comments on the method used.

## What can be done with it?

You can make your own calculation method that uses various data from the rating item to calculate your own rating.

## What about exiting ratings?

The calculation function will be run after every rating, and it will also run when using Recalculation tool.

## Create own plugin based on this code

You can use this code base as a base for your own plugin. The way this plugin is designed, it should be located in the directory named `gdrts-custom-rating-calculation`. If you want, you can use the code inside your own custom plugin.
