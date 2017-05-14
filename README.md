# Create words translation API

## Installation note
* git clone https://github.com/bozanbungee/words-translation-API.git
* via terminal $> **composer update** (install all vendors)
* Create Database schema **translate-en-app** in MySql
* Connect DB via **.env** file
* via terminal $> **php artisan migrate**    (create table in DB Schema)
* via terminal $> **php -S localhost:8000 -t public**  (local web server on port 8000)



## API Documentation 


#### Login restriction with 1 account configured through the config file.

Login restriction trough middleware via boot method in /app/Providers/AuthServiceProvider.php
* API accept Api-Token(key) and  value that have to be the same as API_KEY in .env file
* Should be sent for store, update and destroy method.


### Simple CRUD for words that we have in the database


#### Database 
* Fields (id, word, word_in_bg, meaning, created_at, updated_at);
* php artisan command for migration trough app/database/migration
* php artisan command for Fake database through database Seeder in /app/database/seeds

# CRUD OPERATION

## API for store, update, destroy
  
  * POST  **http://localhost/api/v1/store/**  
    * Parameters via body [{key:word value:word in English}, {key:meaning value:meaning in english} ] 
    * controller: 'TranslateController@store' -Protected via Auth (accept Api-Token in header)
    * This method will store a row to Database.
    * Word in English will be translated via method getEnToBgString($string) in /app/Http/Controller/Controller.php
  
  * PUT  **http://localhost/api/v1/update/{id}**      
     * Parameters via body [{key:word value:word in English}, {key:meaning value:meaning in english} ]  and {id} from DB.
     * controller: 'TranslateController@update' -Protected via Auth (accept Api-Token in header)
     * This method will update a row to Database.
     * Word in English will be translated via method getEnToBgString($string) in /app/Http/Controller/Controller.php
  
  * DELETE **http://localhost/api/v1/destroy/{id}**        
       * controller: 'TranslateController@destroy' -Protected via Auth (accept Api-Token in header)
       * {id} from DB.
       * This method will delete a row from Database.
      
  
## API for get data 
  
  * GET **http://localhost/api/v1/show/id/{id}**
   
      * controller: 'TranslateController@show' without Auth
      * {id} from DB.
      * This method will return a row from Database.
   
  * GET  **http://localhost/api/v1/show/word/{word}**
     
      * controller:  'TranslateController@showWord' without Auth
      * {word} from DB.
      * This method will return a row from Database.
      
      
  * GET **http://localhost/api/v1/show/paginate/{perPage}**
         
      * controller:'TranslateController@paginate' without Auth
      * {perPage}. How many rows per page.
      * This method will return paginated data from Database.
      * Additional fields from response for pagination.

## API for putting data via CSV file

### Method via multipart/form 

##### The only route which accepts api-token via get parameter ?api-token=API-Key from .env file
  * GET **http://localhost/load_csv**
         
      * controller: 'CsvController@loadCsv' 
      * This method will return html form. User can send via multipart/form'
      * Submit to 'http://localhost/api/v1/csv/get_csv_from_upload
   

### Method via POST and csv in server folder app/public/csv/

  * POST **http://localhost/api/v1/csv/get_csv_from_folder**
       * post parameter filename=name of csv from /public/csv folder without .csv extension*
       * controller: 'CsvController@getFromFolder'      
       * This method will upload batch data to database from csv file in /public/csv folder
         
   
