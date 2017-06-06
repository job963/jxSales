# jxSales

**Module for filtering orders and customers by products.**

This module shows all products according the specified filter and the customers which have bought these products. This can be helpful eg. when you have to inform all customers because of an issue like a callback. 

![show products and customers](/docs/img/productsandcustomers.png)


## Setup ##

1. Unzip the complete file with all the folder structures and upload the content of the folder copy_this to the root folder of your shop.  
OR  
Install the [ioly OXID-Connector](https://github.com/ioly/ioly/tree/connector-oxid) (if you haven't done that already), type _jxSales_ in searchbox and click on `Install`.  

2. After this navigate in the admin backend of the shop to _Extensions_ - _Modules_. Select the module _jxSales_ and click on `Activate`.

If you open the menu _Orders_, you will see the the new menu items _Article-Customer Analysis_ and _Latest Orders_.


## Release history ##

- **0.3 - Initial public release**
	- Support for multi-lingual shops
	- Support for CE, PE and EE shops 
	- Support of OXID versions 4.7, 4.8 and 4.9

- **0.4 - Latest orders report**
	- Compatible with 4.10 as well (checked)
	- Report for latest orders added
	- Print function added to all pages
	- Error on EE version fixed


## License

This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
General Public License as published by the Free Software Foundation; either version 3 of the License, 
or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
General Public License for more details. You should have received a copy of the GNU General Public License 
along with this program; if not, see http://www.gnu.org/licenses/
