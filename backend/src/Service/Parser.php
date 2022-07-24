#!/usr/bin/env php
<?php

namespace App\Service;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Book;
use App\Repository\BookRepository;

class Parser
{
    private $logger;
    private $bookRepository;

    public function __construct(
        LoggerInterface $logger,
        BookRepository $bookRepository)
    {
        $this->logger = $logger;
        $this->bookRepository = $bookRepository;
    }

    private function get_decoded_json()
    {
        $filename = 'var/cache/books.json';
        $json = '';
        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $logger->info('File read from cache');
            return json_decode($json);
        }

        $url = 'https://gitlab.com/prog-positron/test-app-vacancy/-/raw/master/books.json';
        $logger->info('Downloading file from '.$url);
        $json = file_get_contents($url);
        if (!$json) {
            $logger->info('Download ERROR');
            return FALSE;
        }

        $logger->info('File downloaded');
        file_put_contents($filename, $json);
        $logger->info('File written to cache');
        return json_decode($json);
    }

    private function log(int $id, object $book, string $propertyName) {
        if (property_exists($book, $propertyName)) {
            $val = $book->$propertyName;
            $logger->info("[$id][$propertyName] $val");
        }
    }

    public function run()
    {
        $books = $this->get_decoded_json($logger);
        if (!$books) {
            return;
        }
        
        return $books;

        $em = $this->entityManager;

        $authors = array();
        foreach($books as $id=>$book) {
            $dbBook = new Book();

            $logger->info("[$id][Title] $book->title");

            $dbBook->setTitle($book->title);
            $dbBook->setIsbn($book->isbn);
            $dbBook->setPageCount($book->pageCount);
            $dbBook->setStatus($book->status);

            // $dbBook->setPublishedDate($book->pageCount);
            // $dbBook->setThumbnailUrl($book->pageCount);
            // $dbBook->setShortDescription($book->pageCount);
            // $dbBook->setLongDescription($book->pageCount);

            // $this->log($logger, $id, $book, 'publishedDate');
            $this->log($logger, $id, $book, 'shortDescription');
            $this->log($logger, $id, $book, 'longDescription');
            $this->log($logger, $id, $book, 'thumbnailUrl');
            // $logger->info($id.': '.$book->authors);
            // $logger->info($id.': '.$book->categories);
            $logger->info("");
            $em->persist($dbBook);
        }
        $em->flush();
    }
}