# transformer

* Programación Funcional
  - Funciones de primera clase y de orden superior
  - Funciones puras (no side effects)
  - Immutabilidad

        $dateStart = DateTimeImmutable::createFromFormat('Y-m-d', '2015-01-25');
        $dateEnd = $dateStart->add(new DateInterval('P10D'));
             

Anonymous functions

Transformaciones

data(array(
    ['name' => 'Juan Perez', 'languages' => ['php', 'javascript'], 'gender' => 'male',
    ['name' => 'Ivonne Armenta', 'languages' => ['php', 'ruby'], 'gender' => 'female'
    ['name' => 'Edgar Gutierrez', 'languages' => ['java'], 'gender' => 'male',
    ['name' => 'Lizbeth Jimenez', 'languages' => ['python', 'php', 'javascript'], 'gender' => 'female'
))
->map(function ($item) {
    return $item['name'];
})->get();


['Juan Perez', 'Ivonne Armenta', 'Edgar Gutierrez', 'Lizbeth Jimenez']

Programador PHP

->filter(function($item) {
    return in_array('php', $item['languages'])
})->map(function ($item) {
    return $item['name'];
})->get();

['Juan Perez', 'Ivonne Armenta', 'Lizbeth Jimenez']

Programador PHP, agrupados por genero

->filter(function($item) {
    return in_array('php', $item['languages'])
})->partition(function($item) {
    return $item['gender'];
})->get();

[
    'male' => ['Juan Perez']l,
    'female' => ['Ivonne Armenta', 'Lizbeth Jimenez']
]


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