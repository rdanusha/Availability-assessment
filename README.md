# Setup Instructions

1. Download or clone the repository to your www folder
2. Create a database and Import the given sql file (assessment.sql)
3. Update database connection information on Database.php
4. Open a web browser and enter the address


#User Guide

## Availability Check

**METHOD:** ```GET```

**URL STRUCTURE:** 

``` http://{domain}/check-availability.php?equipment-id={id}&qty={qty}&start={start}&end={end} ```

**PARAMETERS**

- **equipment-id** *Integer* ID of the equipment
- **qty** *Integer* Quantity which need to check the availability
- **start** *String* Start date
- **end** *String* End date

**Example:**

``` http://abc.local/check-availability.php?equipment-id=14&qty=1&start=2019-06-27&end=2019-06-30 ```



## Get Shortages

**METHOD:** ```GET```

**URL STRUCTURE:**

``` http://{domain}/check-shortages.php?start={start}&end={end} ```

**PARAMETERS**

- **start** *String* Start date
- **end** *String* End date

**Example:**

``` http://abc.local/check-shortages.php?start=2019-06-17&end=2019-06-30 ```



