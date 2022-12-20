<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactNew;
use App\Form\Type\ContactUpdate;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

class ContactControllerPhpController extends AbstractController
{
    public function index(
        ManagerRegistry $doctrine,
        Request $request,
        PaginatorInterface $paginator,
        FormFactoryInterface $formFactory
    ): Response
    {

        $contacts = $doctrine->getRepository(Contact::class)->findAll();

        $allContacts = $paginator->paginate(
            $contacts,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(
            'contact_controller_php/index.html.twig',
            [
                'contacts' => $allContacts,
                'search' => False
            ]
        );

    }

    public function search(
        ManagerRegistry $doctrine,
        Request $request,
        PaginatorInterface $paginator,
        string $search_string): Response
    {
        $contacts = $doctrine->getRepository(Contact::class)->findByExampleField($search_string);

        $allContacts = $paginator->paginate(
            $contacts,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(
            'contact_controller_php/index.html.twig',
            [
                'contacts' => $allContacts,
                'search' => True,
                'searchedTerm' => $search_string
            ]
        );
    }

    public function remove(ManagerRegistry $doctrine, Contact $contact): Response
    {

        $entityManager = $doctrine->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();
        return $this->redirectToRoute(
            'contacts_all'
        );

    }

    public function detail(Contact $contact): Response
    {
        return $this->renderForm('contact_controller_php/detail.html.twig', [
            'contact_id' => $contact->getId(),
            'contact_name' => $contact->getName(),
            'contact_secondname' => $contact->getSecondname(),
            'contact_phone' => $contact->getPhone(),
            'contact_email' => $contact->getEmail(),
            'contact_note' => $contact->getNote(),
        ]);


    }

    public function new(
        ValidatorInterface $validator,
        ManagerRegistry $doctrine,
        FormFactoryInterface $formFactory,
        Request $request): Response
    {

        $contact = new Contact();
        $contact->setName('this name');
        $contact->setSecondname('and this secondname');
        $contact->setPhone(654654654);
        $contact->setEmail('with email');
        $contact->setNote('note to this');

        $form = $this->createForm(ContactNew::class, $contact);
        $form = $formFactory->createNamed("ContactForm", ContactNew::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $errors = $validator->validate($contact);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }
            $entityManager->flush();
            return $this->redirectToRoute(
                'contacts_all'
            );
        }

        return $this->renderForm('contact_controller_php/new.html.twig', [
            'form' => $form,
        ]);

    }

    public function updateFromID(
        ContactRepository $contactRepositoryRepository,
        FormFactoryInterface $formFactory,
        Request $request,
        int $id): Response
    {

        $contactDataReceived = $contactRepositoryRepository->find($id);
        $processedName = $contactDataReceived->processNameUrl();
        return $this->redirectToRoute('contact_update_slug', array("slug"=>$id."-".$processedName));

    }

    public function update(
        ValidatorInterface $validator,
        ManagerRegistry $doctrine,
        string $slug,
        ContactRepository $contactRepositoryRepository,
        FormFactoryInterface $formFactory,
        Request $request): Response
    {

        if(str_contains($slug, '-') && ($id = explode("-", $slug)[0])){
            $contactDataReceived = $contactRepositoryRepository->find($id);
        }

        $contact = new Contact();
        $contact->setName($contactDataReceived->getName());
        $contact->setSecondname($contactDataReceived->getSecondname());
        $contact->setPhone($contactDataReceived->getPhone());
        $contact->setEmail($contactDataReceived->getEmail());
        $contact->setNote($contactDataReceived->getNote());

        // $form = $this->createForm(ContactUpdate::class, $contact);
        $form = $formFactory->createNamed("UpdateContact", ContactUpdate::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $request->isMethod('POST')) {

            $contact = $form->getData();
            $entityManager = $doctrine->getManager();

            if (!$contactDataReceived) {
                throw new \Exception('Invalid object Contact has been passed to update');
            }

            $contactDataReceived->setName($contact->getName());
            $contactDataReceived->setSecondname($contact->getSecondname());
            $contactDataReceived->setPhone($contact->getPhone());
            $contactDataReceived->setEmail($contact->getEmail());
            $contactDataReceived->setNote($contact->getNote());

            $errors = $validator->validate($contactDataReceived);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $entityManager->flush();
            return $this->redirectToRoute(
                'contacts_all'
            );
        }

        return $this->renderForm('contact_controller_php/update.html.twig', [
            'form' => $form,
            'contact_id' => $contactDataReceived->getId(),
            'contact_name' => $contactDataReceived->getName(),
        ]);

    }

    public function processStringUrl(string $str): string
    {
        return str_replace("", "-", mb_strtolower(strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY')));
    }




}
