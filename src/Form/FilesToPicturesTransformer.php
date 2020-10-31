<?php

namespace App\Form;

use App\Entity\PhotoArticle;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;

class FilesToPicturesTransformer implements DataTransformerInterface
{

    public function transform($value): void
    {
        // TODO: Implement transform() method.
    }

    public function reverseTransform($value): ArrayCollection
    {
        $pictures = new ArrayCollection();

        foreach ($value as $file) {
            $picture = (new PhotoArticle())
                ->setImageFile($file);
            if (!$pictures->contains($picture)) {
                $pictures->add($picture);
            }
        }
        return $pictures;
        // TODO: Implement reverseTransform() method.
    }
}