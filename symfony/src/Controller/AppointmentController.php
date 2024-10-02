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
     * @Route("/api/appointments", methods={"GET"})
     * 
     * Returns a list of all appointments.
     *
     * @return Response
     */
    public function getAppointments(): Response
    {
        $appointments = $this->entityManager->getRepository(Appointment::class)->findAll();
        return $this->json($appointments);
    }

    /**
     * @Route("/api/appointments", methods={"POST"})
     * 
     * Creates a new appointment.
     * 
     * Expects a JSON payload with the following structure:
     * {
     *     "date": "YYYY-MM-DD",
     *     "description": "string"
     * }
     *
     * @param Request $request
     * @return Response
     */
    public function createAppointment(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['date'])) {
            return $this->json(['error' => 'Date is required'], Response::HTTP_BAD_REQUEST);
        }

        $appointment = new Appointment();
        $appointment->setDate(new \DateTime($data['date']));

        if (isset($data['description'])) {
            $appointment->setDescription($data['description']);
        }

        $this->entityManager->persist($appointment);
        $this->entityManager->flush();

        return $this->json($appointment, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/appointments/{id}", methods={"GET"})
     * 
     * Returns a specific appointment by ID.
     *
     * @param int $id
     * @return Response
     */
    public function getAppointment(int $id): Response
    {
        $appointment = $this->entityManager->getRepository(Appointment::class)->find($id);

        if (!$appointment) {
            return $this->json(['error' => 'Appointment not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($appointment);
    }

    /**
     * @Route("/api/appointments/{id}", methods={"PUT"})
     * 
     * Updates an existing appointment by ID.
     * 
     * Expects a JSON payload with optional properties:
     * {
     *     "date": "YYYY-MM-DD",
     *     "description": "string"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateAppointment(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $appointment = $this->entityManager->getRepository(Appointment::class)->find($id);

        if (!$appointment) {
            return $this->json(['error' => 'Appointment not found'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['date'])) {
            $appointment->setDate(new \DateTime($data['date']));
        }

        if (isset($data['description'])) {
            $appointment->setDescription($data['description']);
        }

        $this->entityManager->flush();

        return $this->json($appointment);
    }

    /**
     * @Route("/api/appointments/{id}", methods={"DELETE"})
     * 
     * Deletes a specific appointment by ID.
     *
     * @param int $id
     * @return Response
     */
    public function deleteAppointment(int $id): Response
    {
        $appointment = $this->entityManager->getRepository(Appointment::class)->find($id);

        if (!$appointment) {
            return $this->json(['error' => 'Appointment not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($appointment);
        $this->entityManager->flush();

        return $this->json(['message' => 'Appointment deleted'], Response::HTTP_NO_CONTENT);
    }
}