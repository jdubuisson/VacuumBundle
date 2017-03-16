<?php

namespace Victoire\DevTools\VacuumBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Victoire\DevTools\VacuumBundle\Entity\DataContainer\WordPressDataContainer;
use Victoire\DevTools\VacuumBundle\Entity\Playload;

/**
 * Class BlogImportCommand
 * @package Victoire\VacuumBundle\Command
 */
class BlogImportCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('victoire:blog-import')
            ->setDefinition([
                new InputOption('blog', '-b', InputOption::VALUE_REQUIRED, 'The name of the blog to populate'),
                new InputOption('dump', '-d', InputOption::VALUE_REQUIRED, 'Path to the dump who should bee imported'),
                new InputOption('new', '-new', InputOption::VALUE_OPTIONAL, 'Force new blog generation')
            ])
            ->setDescription('Import blog form dump')
            ->setHelp(<<<'EOT'
    The <info>victoire:blog-import</info> command helps you to import blog contents from a dump.

    Any passed option will be used as a default value for the interaction
    
    <info>Required option</info>
    
    <comment>-b --blog</comment> is required it expect a blog name
    <comment>-d --dump</comment> is required it expect a path to the dump
    
    <info>php app/console victoire:blog-import --blog=MyVictoireBlog --dump=/Path/To/My/Dump</info>
    
    <info>Other option</info>
    
    <comment>-new --new</comment> will generate a new blog 
    
    If you want to disable any user interaction, use <comment>--no-interaction</comment> but don't forget to pass all needed options:
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $blog = $input->getOption('blog');

        if (null == $blog) {
            $output->writeln('<error>missing argument blog</error>');
        }

        $pathToDump = $input->getOption('dump');

        if (null == $pathToDump) {
            $output->writeln('<error>missing argument path</error>');
        }

        if (!realpath($pathToDump)) {
            $output->writeln('<error>Wrong path the file '.$pathToDump.' can\'t be found</error>');
        }

        $data = simplexml_load_file($pathToDump);
        $playload = new Playload();

        foreach ($data->channel as $children) {
            foreach ($children as $key => $item) {
                $playload->addResult($item);
            }
        }

        $container = $this->getContainer();
        $container->get('victoire.vacuum_bundle.word_press_processor')->process($stages, $playload);
    }
}