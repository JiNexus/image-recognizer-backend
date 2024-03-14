<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Entity\ImageLabel;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Ramsey\Uuid\Uuid;

class ImageLabelFixture extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $reader = new Csv();
        $spreadsheet = $reader->load(LOCAL_STORAGE_FIXTURE_CSV . 'image-label.csv');
        $activeSheet = $spreadsheet->getActiveSheet();
        $data = $activeSheet->toArray();

        $header = $data[0];
        array_splice($data, 0, 1);

        foreach($data as $value) {
            $imageLabel = new ImageLabel([
                'id' => Uuid::fromString($value[array_search('id', $header)]),
                'name' => $value[array_search('name', $header)],
                'createdAt' => new DateTime($value[array_search('created_at', $header)]),
                'updatedAt' => new DateTime($value[array_search('updated_at', $header)]),
            ]);

            $manager->persist($imageLabel);
            $manager->flush();
        }
    }
}
