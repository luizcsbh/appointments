<?php 
namespace App\Controller;

use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/appointments", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $appointments = $this->entityManager->getRepository(Appointment::class)->findAll();
        return $this->json([
            'data' => $appointments
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/api/appointments/{id}", name="show",  methods={"GET"})
     */
    public function show(int $id): Response
    {
        $appointment = $this->entityManager->getRepository(Appointment::class)->find($id);

        if (!$appointment) {
            return $this->json([
                'error' => 'Appointment not found'
            ], Response::HTTP_NOT_FOUND
            );
        }

        return $this->json([
            'data' => $appointment
            ], Response::HTTP_OK
        );
    }


    /**
     * @Route("/api/appointments", name="create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = $request->request->all();
        
        if (!isset($data['date'])) {
            return $this->json([
                'error' => 'Date is required'
                ], Response::HTTP_BAD_REQUEST
            );
        }

        $appointment = new Appointment();
        $appointment->setDate(new \DateTime($data['date']));
        $appointment->setDescription($data['description']);

        $this->entityManager->persist($appointment);
        $this->entityManager->flush();

        return $this->json([
            'data' => 'Appointment criado com sucesso!'
            ], Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/appointments/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Request $request, int $id): Response
    {

        $data = json_decode($request->getContent(), true);
        $appointment = $this->entityManager->getRepository(Appointment::class)->find($id);

        if (!$appointment) {
            return $this->json([
                    'error' => 'Appointment not found'
                ], Response::HTTP_NOT_FOUND
            );
        }

        if (isset($data['date'])) {
            $appointment->setDate(new \DateTime($data['date']));
        }

        if (isset($data['description'])) {
            $appointment->setDescription($data['description']);
        }

        $this->entityManager->flush();

        return $this->json([
                'data' => $appointment
            ], Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/appointments/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $appointment = $this->entityManager->getRepository(Appointment::class)->find($id);

        if (!$appointment) {
            return $this->json([
                    'error' => 'Appointment not found'
                ], Response::HTTP_NOT_FOUND
            );
        }

        $this->entityManager->remove($appointment);
        $this->entityManager->flush();

        return $this->json([
                'message' => 'Appointment deleted'
            ], Response::HTTP_NO_CONTENT
        );
    }
}