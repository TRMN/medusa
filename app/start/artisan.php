<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new ImportChapters());
Artisan::add(new ImportUsers());
Artisan::add(new ImportGrades());
Artisan::add(new ViewsCommand());
Artisan::add(new CodeTest());
Artisan::add(new AddPermission());
Artisan::add(new CreateEchelons());
Artisan::add(new assignAHPerms());