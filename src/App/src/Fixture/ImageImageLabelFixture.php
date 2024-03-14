<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Image;
use App\Entity\ImageImageLabel;
use App\Entity\ImageLabel;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Ramsey\Uuid\Uuid;

class ImageImageLabelFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return void
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $imageRepository = $manager->getRepository(Image::class);
        $imageLabelRepository = $manager->getRepository(ImageLabel::class);

        $reader = new Csv();
        $spreadsheet = $reader->load(LOCAL_STORAGE_FIXTURE_CSV . 'image-image-label.csv');
        $activeSheet = $spreadsheet->getActiveSheet();
        $data = $activeSheet->toArray();

        $header = $data[0];
        array_splice($data, 0, 1);

        foreach($data as $value) {
            $image = $imageRepository->find($value[array_search('image_id', $header)]);
            $imageLabel = $imageLabelRepository->find($value[array_search('image_label_id', $header)]);

            $imageLabel = new ImageImageLabel([
                'id' => Uuid::fromString($value[array_search('id', $header)]),
                'image' => $image,
                'imageLabel' => $imageLabel,
                'createdAt' => new DateTime($value[array_search('created_at', $header)]),
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
        return [ImageLabelFixture::class, ImageFixture::class];
    }
}
