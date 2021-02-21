<?php
declare(strict_types = 1);

return [

    \GeorgRinger\News\Domain\Model\News::class => [
        'subclasses' => [
            '\Yawave\Yawave\Domain\Model\Publications' => \Yawave\Yawave\Domain\Model\Publications::class,
        ]
    ],
    \GeorgRinger\News\Domain\Model\Tag::class => [
        'subclasses' => [
            '\Yawave\Yawave\Domain\Model\Tag' => \Yawave\Yawave\Domain\Model\Tag::class,
        ]
    ],
    \GeorgRinger\News\Domain\Model\Category::class => [
        'subclasses' => [
            '\Yawave\Yawave\Domain\Model\Category' => \Yawave\Yawave\Domain\Model\Category::class,
        ]
    ],

    \Yawave\Yawave\Domain\Model\Publications::class => [
        'tableName' => 'tx_news_domain_model_news',
        'recordType' => 'Tx_Yawave_Publications',
    ],
    \Yawave\Yawave\Domain\Model\Tag::class => [
        'tableName' => 'tx_news_domain_model_tag',
        'recordType' => 'Tx_Yawave_Tag',
    ],
    \Yawave\Yawave\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
        'recordType' => 'Tx_Yawave_Category',
    ],
];

