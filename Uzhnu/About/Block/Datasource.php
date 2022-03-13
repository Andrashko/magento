<?php

namespace Uzhnu\About\Block;

use \Magento\Framework\View\Element\Template;

class Datasource extends Template
{
    public function getAuthor(): array
    {
        return [
            "Name" => "Yurii",
            "Email" => "yurii.andrashko@uzhnu.edu.ua",
            "Avatar"=> [
                "Url" => "https://devdocs.magento.com/assets/i/adobe-a.svg",
                "Size" => 128
            ],
            "Subjects" => ["Magento", "Data Scraping", "Web-programing", "ASP.NET"]
        ];
    }

    public function getVariant(): int
    {
        return 42;
    }
}
