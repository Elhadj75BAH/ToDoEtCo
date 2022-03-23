<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list" ,methods={"GET"})
     */
    public function listAction(TaskRepository $taskRepository):Response
    {
        return $this->render('task/list.html.twig',
            ['tasks' =>$taskRepository ->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create" ,methods={"GET","POST"})
     */
    public function createAction(Request $request, TaskRepository $taskRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $task->setUser($this->getUser());
            $taskRepository->add($task);
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit" ,methods={"GET","POST"})
     */
    public function editAction(Task $task, Request $request, TaskRepository $taskRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
            $taskRepository->add($task);

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle" ,methods={"GET","POST"})
     */
    public function toggleTaskAction(Task $task, TaskRepository $taskRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $task->toggle(!$task->isDone());
        $taskRepository->add($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete" ,methods={"POST"})
     */
    public function deleteTaskAction(Task $task, Request $request, TaskRepository $taskRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if($this->isCsrfTokenValid('delete'.$task->getId(),$request->request->get('_token'))){
            $taskRepository->remove($task);
        }

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
