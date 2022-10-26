<?php
namespace App\Form\DataTransformer;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class ImageToFileTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (image) to a file (Uploaded file).
     *
     * @param  UploadedFile|null $file
     */
    public function transform($file)
    {
        // dd($file);
        // if (!$file) {
        //     return null;
        // }
        // return $file->getLink();
    }



    /**
     * Transforms a file (Uploaded file) to an object (image).
     *
     * @param  file $file_image
     * @throws TransformationFailedException if object (image) is not found.
     */
    public function reverseTransform($file_image): ?Image
    {
        // no image number? It's optional, so that's ok
        if (!$file_image) {
            alert("Fichier non reçu");
            return null;
        }

        $image = $this->entityManager
            ->getRepository(Image::class)
            // query for the image with this id
            ->find($file_image)
        ;

        if ($image === null) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An image with number "%s" does not exist!',
                $imageNumber
            ));
        }

        return $image;
    }
}
