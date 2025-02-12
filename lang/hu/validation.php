<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validációs nyelvi sorok
    |--------------------------------------------------------------------------
    |
    | Az alábbi nyelvi sorok az alapértelmezett hibaüzeneteket tartalmazzák,
    | amelyeket az ellenőrző osztály használ. Néhány szabálynak több verziója
    | is lehet, például a méret szabályok esetében. Nyugodtan módosítsd
    | ezeket az üzeneteket az igényeid szerint.
    |
    */

    'accepted' => 'A(z) :attribute el kell fogadni.',
    'accepted_if' => 'A(z) :attribute akkor kell elfogadni, ha a(z) :other :value.',
    'active_url' => 'A(z) :attribute érvényes URL kell, hogy legyen.',
    'after' => 'A(z) :attribute dátumnak későbbinek kell lennie, mint :date.',
    'after_or_equal' => 'A(z) :attribute dátumnak :date utáninak vagy azzal egyenlőnek kell lennie.',
    'alpha' => 'A(z) :attribute csak betűket tartalmazhat.',
    'alpha_dash' => 'A(z) :attribute csak betűket, számokat, kötőjeleket és aláhúzásokat tartalmazhat.',
    'alpha_num' => 'A(z) :attribute csak betűket és számokat tartalmazhat.',
    'array' => 'A(z) :attribute egy tömb kell, hogy legyen.',
    'ascii' => 'A(z) :attribute csak egybájtos alfanumerikus karaktereket és szimbólumokat tartalmazhat.',
    'before' => 'A(z) :attribute dátumnak korábbinak kell lennie, mint :date.',
    'before_or_equal' => 'A(z) :attribute dátumnak :date előttinek vagy azzal egyenlőnek kell lennie.',
    'between' => [
        'array' => 'A(z) :attribute :min és :max elem között kell lennie.',
        'file' => 'A(z) :attribute méretének :min és :max kilobájt között kell lennie.',
        'numeric' => 'A(z) :attribute :min és :max között kell lennie.',
        'string' => 'A(z) :attribute :min és :max karakter között kell lennie.',
    ],
    'boolean' => 'A(z) :attribute mezőnek igaznak vagy hamisnak kell lennie.',
    'can' => 'A(z) :attribute mező tiltott értéket tartalmaz.',
    'confirmed' => 'A(z) :attribute megerősítése nem egyezik.',
    'contains' => 'A(z) :attribute mező egy szükséges értéket hiányol.',
    'current_password' => 'A megadott jelszó helytelen.',
    'date' => 'A(z) :attribute érvényes dátum kell, hogy legyen.',
    'date_equals' => 'A(z) :attribute dátumnak meg kell egyeznie ezzel: :date.',
    'date_format' => 'A(z) :attribute nem egyezik meg a következő formátummal: :format.',
    'decimal' => 'A(z) :attribute :decimal tizedesjegyet kell tartalmazzon.',
    'declined' => 'A(z) :attribute el kell utasítani.',
    'declined_if' => 'A(z) :attribute el kell utasítani, ha a(z) :other :value.',
    'different' => 'A(z) :attribute és a(z) :other különböző kell, hogy legyen.',
    'digits' => 'A(z) :attribute :digits számjegyből kell álljon.',
    'digits_between' => 'A(z) :attribute :min és :max számjegy között kell legyen.',
    'dimensions' => 'A(z) :attribute érvénytelen kép dimenziókkal rendelkezik.',
    'distinct' => 'A(z) :attribute mező ismétlődő értéket tartalmaz.',
    'doesnt_end_with' => 'A(z) :attribute nem végződhet a következőkkel: :values.',
    'doesnt_start_with' => 'A(z) :attribute nem kezdődhet a következőkkel: :values.',
    'email' => 'A(z) :attribute érvényes e-mail cím kell, hogy legyen.',
    'ends_with' => 'A(z) :attribute a következő egyikével kell végződjön: :values.',
    'enum' => 'A kiválasztott :attribute érvénytelen.',
    'exists' => 'A kiválasztott :attribute érvénytelen.',
    'extensions' => 'A(z) :attribute egyik következő kiterjesztésű kell, hogy legyen: :values.',
    'file' => 'A(z) :attribute fájl kell, hogy legyen.',
    'filled' => 'A(z) :attribute mezőnek tartalmaznia kell egy értéket.',
    'gt' => [
        'array' => 'A(z) :attribute több mint :value elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute méretének nagyobbnak kell lennie, mint :value kilobájt.',
        'numeric' => 'A(z) :attribute nagyobbnak kell lennie, mint :value.',
        'string' => 'A(z) :attribute hosszabb kell legyen, mint :value karakter.',
    ],
    'lte' => [
        'array' => 'A(z) :attribute nem tartalmazhat több mint :value elemet.',
        'file' => 'A(z) :attribute nem lehet nagyobb, mint :value kilobájt.',
        'numeric' => 'A(z) :attribute nem lehet nagyobb, mint :value.',
        'string' => 'A(z) :attribute nem lehet hosszabb, mint :value karakter.',
    ],
    'max' => [
        'array' => 'A(z) :attribute nem lehet több mint :max elem.',
        'file' => 'A(z) :attribute mérete nem lehet nagyobb, mint :max kilobájt.',
        'numeric' => 'A(z) :attribute nem lehet nagyobb, mint :max.',
        'string' => 'A(z) :attribute nem lehet hosszabb, mint :max karakter.',
    ],
    'min' => [
        'array' => 'A(z) :attribute legalább :min elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute legalább :min kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute legalább :min kell legyen.',
        'string' => 'A(z) :attribute legalább :min karakter kell legyen.',
    ],
    'required' => 'A(z) :attribute mező kitöltése kötelező.',
    'unique' => 'A(z) :attribute már foglalt.',
    'url' => 'A(z) :attribute érvényes URL kell, hogy legyen.',

    /*
    |--------------------------------------------------------------------------
    | Egyéni validációs üzenetek
    |--------------------------------------------------------------------------
    |
    | Itt adhatsz meg egyéni validációs üzeneteket bizonyos attribútumokra és
    | szabályokra a következő formátumban: "attribute.rule" => "üzenet".
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'egyéni üzenet',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Egyéni attribútum nevek
    |--------------------------------------------------------------------------
    |
    | Az alábbi nyelvi sorok lehetővé teszik, hogy olvashatóbb neveket adj
    | az attribútumoknak, például "E-Mail Cím" ahelyett, hogy "email".
    |
    */

    'attributes' => [],

];
