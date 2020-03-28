# Practice_oop
oop php
## About
Redoing this legacy project that i did couple years ago which is a pretty simple project based on ShopCart Application. Taking from some inspiration from Laravel i tried making it a bit more from scratch.

## Setting Up

### Requirements
- Use PHP 7.3

Entry Point too the program is Index.php no FE currently


## Running Tests [Testing] 

### Customer Model [Mocking The Request With Symfony Request]
- Run `./vendor/bin/phpunit Test/Integration/Model/CustomerModelTest.php  ` to make sure you have the right database details
- Run `./vendor/bin/phpunit Test/Integration/Model/ProductModelTest.php  `
- Run `./vendor/bin/phpunit ./vendor/bin/phpunit Test/Unit/Validation/CustomerTest.php  ` 
- Run `./vendor/bin/phpunit ./vendor/bin/phpunit Test/Unit/Validation/CurrencyTest.php  `

### TODO:
- Finish off Models 
- Add in necessary validation involved
- Add methods for transaction model
- Need too add test for transaction model
- create controllers and handle custom routing 
- Figure way to return data to controller to the view
- do simple front view
