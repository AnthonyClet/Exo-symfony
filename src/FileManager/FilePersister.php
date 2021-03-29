<?php


namespace App\FileManager;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class FilePersister
{

    private $slugger;

    private $parameterBag;

    public function __construct(SluggerInterface $slugger, ParameterBagInterface $parameterBag)
    {
        $this->slugger = $slugger;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Sauve un fichier upload
     */
    public function saveFile($article, $articleForm)
    {
        $file = $articleForm->get('image')->getData();

        if ($file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFile = $this->slugger->slug($originalName);
            $newFile = $safeFile.'-'.uniqid().'.'.$file->guessExtension();
        }

        try {
            $file->move(
                $this->parameterBag->get('images_directory'),
                $newFile
            );
        } catch (FileException $e) {
            throw new \Exception("le fichier n'a pas pu être enregistré");
        }

        $article->setImage($newFile);

        return $article;
    }

}