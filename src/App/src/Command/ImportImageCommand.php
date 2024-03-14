<?php

declare(strict_types=1);

namespace App\Command;

use App\Manager\ImageImageLabelManager;
use App\Manager\ImageLabelManager;
use App\Manager\ImageManager;
use App\Service\Unsplash\UnsplashService;
use Exception;
use League\Flysystem\FilesystemException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportImageCommand extends Command
{
    /**
     * @param ImageManager $imageManager
     * @param ImageLabelManager $imageLabelManager
     * @param ImageImageLabelManager $imageImageLabelManager
     * @param UnsplashService $unsplashService
     */
    public function __construct(
        private readonly ImageManager $imageManager,
        private readonly ImageLabelManager $imageLabelManager,
        private readonly ImageImageLabelManager $imageImageLabelManager,
        private readonly UnsplashService $unsplashService
    ) {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('data-image-import:load')
            ->setDescription('Load data images from Unsplash to your database and local storage')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command loads data images from Unsplash to your database and local storage:

  <info>php %command.full_name%</info>
EOT
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws FilesystemException
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $imageLabelWithNoAssociatedImage = $this->imageLabelManager->getRepository()->findImageLabelWithNoAssociatedImage();

        if (! $imageLabelWithNoAssociatedImage) {
            $message = 'No more image label with no associated image';
            $symfonyStyle->text($message . '.');

            return Command::SUCCESS;
        }

        $imageLabels = array_slice($imageLabelWithNoAssociatedImage, 0, 10);

        foreach ($imageLabels as $imageLabel) {
            $imageLabel = $this->imageLabelManager->getRepository()->find($imageLabel['il_id']);
            $photos = $this->unsplashService->searchPhotos($imageLabel->getName(), 1, 2);

            foreach ($photos->getResults() as $photo) {
                $url = $this->unsplashService->download($photo['id']);
                $filename = $this->unsplashService->getFilename($url);
                $this->imageManager->saveToLocal($url, $filename);
                $image = $this->imageManager->createImage([
                    'filename' => pathinfo($filename, PATHINFO_FILENAME),
                    'fileExtension' => pathinfo($filename, PATHINFO_EXTENSION),
                    'slug' => $photo['slug'],
                    'description' => $photo['description'],
                ]);

                $this->imageImageLabelManager->createImageImageLabel([
                    'image' => $image,
                    'imageLabel' => $imageLabel,
                ]);
            }
        }

        $message = 'Importing images from Unsplash to yor local storage and database is done';
        $symfonyStyle->text($message . '.');

        return Command::SUCCESS;
    }
}
