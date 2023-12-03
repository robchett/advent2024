#!/usr/bin/env php
<?php
// application.php

require __DIR__ . '/vendor/autoload.php';

use Robchett\Aoc2024\Task;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Cookie;

$application = new Application();

$application->register('get-input')
    ->addArgument('day', InputArgument::REQUIRED)
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        $day = $input->getArgument('day');
        if (!is_numeric($day) || $day < 0 || $day > 25) {
            $output->writeln('Invalid day');
            return Command::FAILURE;
        }
        $filename = __DIR__ . "/inputs/day_$day.txt";
        if (file_exists($filename)) {
            $output->writeln('Input already exists');
            return Command::FAILURE;
        }

        $client = Symfony\Component\HttpClient\HttpClient::create([
            'headers' => [
                'Cookie' => new Cookie('session', $_SERVER['AOC_SESSION'], strtotime('+1 day'))
            ]
        ]);
        $response = $client->request(
            'GET',
            "https://adventofcode.com/2024/day/$day/input"
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $output->writeln("input written to $filename");
            file_put_contents($filename, $response->getContent());
            return Command::SUCCESS;
        }

        $output->writeln('Failed to get input');
        return Command::FAILURE;
    });

$application->register('run-task')
    ->addArgument('day', InputArgument::REQUIRED)
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        $day = $input->getArgument('day');
        if (!is_numeric($day) || $day < 0 || $day > 25) {
            $output->writeln('Invalid day');
            return Command::FAILURE;
        }
        $filename = __DIR__ . "/inputs/day_$day.txt";
        if (!file_exists($filename)) {
            $output->writeln("Day input not loaded run 'get-input $day'");
            return Command::FAILURE;
        }

        /** @var Task $runner */
        $runner = require __DIR__ . "/src/day$day.php";
        $output->writeln("Task 1: " . $runner->task1($runner->parseInput(trim(file_get_contents($filename))))->unwrap());
        $output->writeln("Task 2: " . $runner->task2($runner->parseInput(trim(file_get_contents($filename))))->unwrap());
        return Command::SUCCESS;
    });

$application->register('test-task')
    ->addArgument('username', InputArgument::REQUIRED)
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        // ...

        return Command::SUCCESS;
    });

$application->run();
