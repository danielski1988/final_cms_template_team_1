# VESIT CMS 

A project to design and implement a content management system for both faculties and students in VESIT

## Getting started 

After cloning the repository

```
cd cms
composer install
npm install
```

Next inside `.env` file inside the root directory, edit the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` fields where `DB_CONNECTION` is `mysql`. Edit `DB_HOST` and `DB_PORT` values too if those values aren't default in your machine

##### While defining the routes make sure to add the prefix in order to avoid conflicts in route names.

For eg, if it's faculty module 

```
Route::group(['prefix' => 'faculty'], function() {
    Route::get('', [
        'uses' => 'FacultyController@getIndex',
        'as' => 'faulty.index'
    ]);

    //And so on
});

```

### Compiling your css and sass files

#### Compiling sass into css

`Sass dir:- resources/assets/sass`

In webpack.mix.js, add the sass files you wish to compile to css, inside the `.sass()` function ass first arg. If there are more than 1 sass files, chain one more `.sass()` method

```
mix.sass('resources/assets/SASS_STYLE_1', 'public/css/output_file_1')    
    .sass('resources/assets/SASS_STYLESHEET_2', 'public/css/output_file_2')

```

Make sure you make a note of output files as it'll be required in the next step

#### Combining all css files

`css dir:- resources/assets/css`

Add your css file paths in the array situated inside the .styles method. Unlike sass, multiple chaining is not required

The directories of css files compiled from sass will be required too

```
mix.sass('resources/assets/SASS_STYLE_1', 'public/css/output_file_1')    
    .sass('resources/assets/SASS_STYLESHEET_2', 'public/css/output_file_2')
    .styles(['resources/assets/css/css_file_1', 
           'public/css/output_file_1',
           'public/css/output_file_2',
           'public/css/output_file_1',
           'public/css/output_file_2'],'public/css/final_output_file')

```

After that run 

```
npm run dev 
```

###### PS:- Compile your css files to a stylesheet other than app.css since it's the root file for sbadmin styles and will thus generate a lot of conflicts if they were to merged. 


##### Tips for compiling:-

1. Discuss with team members of your module and come up with a final name where the styles will be outputted

2. Add stylesheets like you normally do in html (multiple stylesheets for a single page, single stylesheets for multiple pages and so on.... your call) and add it's path to webpack.mix.js's styles array/ chain new sass file.

3. Run `npm run dev` 

4. Add the compiled version's name's path inside .gitignore file so that it'll not be tracked by git

5. Also add the compiled style's path inside resources/views/layouts/plane.blade.php

6. When others pull your branch, they just have to run
    `npm run dev`
    to get the outputted css


 
