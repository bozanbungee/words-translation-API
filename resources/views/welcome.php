<html><head><meta charset="utf-8"><title>Untitled Document.md</title><style></style></head><body id="preview">
<h1><a id="Create_words_translation_API_0"></a>Create words translation API</h1>
<h2><a id="Installation_note_2"></a>Installation note</h2>
<ul>
    <li>git clone <a href="https://github.com/bozanbungee/words-translation-API.git">https://github.com/bozanbungee/words-translation-API.git</a></li>
    <li>via terminal $&gt; <strong>composer update</strong> (install all vendors)</li>
    <li>Create Database schema <strong>translate-en-app</strong> in MySql</li>
    <li>Connect DB via <strong>.env</strong> file</li>
    <li>via terminal $&gt; <strong>php artisan migrate</strong>    (create table in DB Schema)</li>
    <li>via terminal $&gt; <strong>php -S localhost:8000 -t public</strong>  (local web server on port 8000)</li>
</ul>
<h2><a id="API_Documentation_12"></a>API Documentation</h2>
<h4><a id="Login_restriction_with_1_account_configured_through_the_config_file_15"></a>Login restriction with 1 account configured through the config file.</h4>
<p>Login restriction trough middleware via boot method in /app/Providers/AuthServiceProvider.php</p>
<ul>
    <li>API accept Api-Token(key) and  value that have to be the same as API_KEY in .env file</li>
    <li>Should be sent for store, update and destroy method.</li>
</ul>
<h3><a id="Simple_CRUD_for_words_that_we_have_in_the_database_22"></a>Simple CRUD for words that we have in the database</h3>
<h4><a id="Database_25"></a>Database</h4>
<ul>
    <li>Fields (id, word, word_in_bg, meaning, created_at, updated_at);</li>
    <li>php artisan command for migration trough app/database/migration</li>
    <li>php artisan command for Fake database through database Seeder in /app/database/seeds</li>
</ul>
<h1><a id="CRUD_OPERATION_30"></a>CRUD OPERATION</h1>
<h2><a id="API_for_store_update_destroy_32"></a>API for store, update, destroy</h2>
<ul>
    <li>
        <p>POST  <strong><a href="http://localhost/api/v1/store/">http://localhost/api/v1/store/</a></strong></p>
        <ul>
            <li>Parameters via body [{key:word value:word in English}, {key:meaning value:meaning in english} ]</li>
            <li>controller: ‘TranslateController@store’ -Protected via Auth (accept Api-Token in header)</li>
            <li>This method will store a row to Database.</li>
            <li>Word in English will be translated via method getEnToBgString($string) in /app/Http/Controller/Controller.php</li>
        </ul>
    </li>
    <li>
        <p>PUT  <strong><a href="http://localhost/api/v1/update/%7Bid%7D">http://localhost/api/v1/update/{id}</a></strong></p>
        <ul>
            <li>Parameters via body [{key:word value:word in English}, {key:meaning value:meaning in english} ]  and {id} from DB.</li>
            <li>controller: ‘TranslateController@update’ -Protected via Auth (accept Api-Token in header)</li>
            <li>This method will update a row to Database.</li>
            <li>Word in English will be translated via method getEnToBgString($string) in /app/Http/Controller/Controller.php</li>
        </ul>
    </li>
    <li>
        <p>DELETE <strong><a href="http://localhost/api/v1/destroy/%7Bid%7D">http://localhost/api/v1/destroy/{id}</a></strong></p>
        <ul>
            <li>controller: ‘TranslateController@destroy’ -Protected via Auth (accept Api-Token in header)</li>
            <li>{id} from DB.</li>
            <li>This method will delete a row from Database.</li>
        </ul>
    </li>
</ul>
<h2><a id="API_for_get_data_52"></a>API for get data</h2>
<ul>
    <li>
        <p>GET <strong><a href="http://localhost/api/v1/show/id/%7Bid%7D">http://localhost/api/v1/show/id/{id}</a></strong></p>
        <ul>
            <li>controller: ‘TranslateController@show’ without Auth</li>
            <li>{id} from DB.</li>
            <li>This method will return a row from Database.</li>
        </ul>
    </li>
    <li>
        <p>GET  <strong><a href="http://localhost/api/v1/show/word/%7Bword%7D">http://localhost/api/v1/show/word/{word}</a></strong></p>
        <ul>
            <li>controller:  ‘TranslateController@showWord’ without Auth</li>
            <li>{word} from DB.</li>
            <li>This method will return a row from Database.</li>
        </ul>
    </li>
</ul>
<ul>
    <li>
        <p>GET <strong><a href="http://localhost/api/v1/show/paginate/%7BperPage%7D">http://localhost/api/v1/show/paginate/{perPage}</a></strong></p>
        <ul>
            <li>controller:‘TranslateController@paginate’ without Auth</li>
            <li>{perPage}. How many rows per page.</li>
            <li>This method will return paginated data from Database.</li>
            <li>Additional fields from response for pagination.</li>
        </ul>
    </li>
</ul>
<h2><a id="API_for_putting_data_via_CSV_file_74"></a>API for putting data via CSV file</h2>
<h3><a id="Method_via_multipartform_76"></a>Method via multipart/form</h3>
<h5><a id="The_only_route_which_accepts_apitoken_via_get_parameter_apitokenAPIKey_from_env_file_78"></a>The only route which accepts api-token via get parameter ?api-token=API-Key from .env file</h5>
<ul>
    <li>
        <p>GET <strong><a href="http://localhost/load_csv">http://localhost/load_csv</a></strong></p>
        <ul>
            <li>controller: ‘CsvController@loadCsv’</li>
            <li>This method will return html form. User can send via multipart/form’</li>
            <li>Submit to ’<a href="http://localhost/api/v1/csv/get_csv_from_upload">http://localhost/api/v1/csv/get_csv_from_upload</a></li>
        </ul>
    </li>
</ul>
<h3><a id="Method_via_POST_and_csv_in_server_folder_apppubliccsv_86"></a>Method via POST and csv in server folder app/public/csv/</h3>
<ul>
    <li>POST <strong><a href="http://localhost/api/v1/csv/get_csv_from_folder">http://localhost/api/v1/csv/get_csv_from_folder</a></strong>
        <ul>
            <li>post parameter filename=name of csv from /public/csv folder without .csv extension*</li>
            <li>controller: ‘CsvController@getFromFolder’</li>
            <li>This method will upload batch data to database from csv file in /public/csv folder</li>
        </ul>
    </li>
</ul>

</body></html>