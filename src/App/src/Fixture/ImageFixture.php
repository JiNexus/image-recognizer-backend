<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Image;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Ramsey\Uuid\Uuid;

class ImageFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return void
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $reader = new Csv();
        $spreadsheet = $reader->load(LOCAL_STORAGE_FIXTURE_CSV . 'image.csv');
        $activeSheet = $spreadsheet->getActiveSheet();
        $data = $activeSheet->toArray();

        $header = $data[0];
        array_splice($data, 0, 1);

        foreach($data as $value) {
            $imageLabel = new Image([
                'id' => Uuid::fromString($value[array_search('id', $header)]),
                'filename' => $value[array_search('filename', $header)],
                'fileExtension' => $value[array_search('file_extension', $header)],
                'slug' => $value[array_search('slug', $header)],
                'description' => $value[array_search('description', $header)],
                'createdAt' => new DateTime($value[array_search('created_at', $header)]),
                'updatedAt' => new DateTime($value[array_search('updated_at', $header)]),
            ]);

            $manager->persist($imageLabel);
            $manager->flush();
        }
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [ImageLabelFixture::class];
    }
}
