# transformer

* Programación Funcional
  - Funciones de primera clase y de orden superior
  - Funciones puras
  - Immutabilidad

Anonymous functions

Closures

function getCache(callable $fn) {
    $cache = [];
    return function() use (&$cache, $fn) {
       $params = func_get_args();
       $key = implode($params, "_");
       if (isset($cache[$key])) {
          return $cache[$key];
       }

       return $cache[$key] = call_user_func_array($fn, $params);
    }
}

$findUser = getCache(function ($id) {
    return $userRepository->find($id);
});

$findUser(1) -> obtiene la informacion de la base de datos
$findUser(1); -> No realiza consulta a la base de datos, regresa el resultado inmediatamente


$calculateBalance = getCache(function($userId) {
    return $accountService->calculateBalance($userId);
});

Transformaciones

data(array(
    ['name' => 'Juan Perez', 'languages' => ['php', 'javascript'], 'gender' => 'male',
    ['name' => 'Ivonne Sanchez', 'languages' => ['php', 'ruby'], 'gender' => 'female'
    ['name' => 'Edgar Gutierrez', 'languages' => ['java'], 'gender' => 'male',
    ['name' => 'Lizbeth Jimenez', 'languages' => ['python', 'php', 'javascript'], 'gender' => 'female'
));

->map(function ($item) {
    return $item['name'];
})->get();

['Juan Perez', 'Ivonne Sanchez', 'Edgar Gutierrez', 'Lizbeth Jimenez']

Quien sepa php

->filter(function($item) {
    return in_array('php', $item['languages'])
})->map(function ($item) {
    return $item['name'];
})->get();

['Juan Perez', 'Ivonne Sanchez', 'Lizbeth Jimenez']

Quien sepa php, separalos por genero

->filter(function($item) {
    return in_array('php', $item['languages'])
})->partition(function($item) {
    return $item['gender'];
})->get();

[
    'male' => ['Juan Perez']l,
    'female' => ['Ivonne Sanchez', 'Lizbeth Jimenez']
]
