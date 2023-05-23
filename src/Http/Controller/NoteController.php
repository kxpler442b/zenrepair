<?php

/**
 * Notes controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\NoteService;
use App\Service\UserService;
use App\Service\TicketService;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use Valitron\Validator;

class NoteController
{
    private readonly Twig $twig;
    private readonly NoteService $notes;
    private readonly UserService $users;
    private readonly TicketService $tickets;
    private readonly SessionInterface $session;

    private string $context = 'note';
    
    public function __construct(ContainerInterface $c)
    {
        $this->twig = $c->get(Twig::class);
        $this->notes = $c->get(NoteService::class);
        $this->users = $c->get(UserService::class);
        $this->tickets = $c->get(TicketService::class);
        $this->session = $c->get(SessionInterface::class);
    }

    /**
     * Returns a HTML form for creating a Note.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function new(Request $request, Response $response): Response
    {
        $user = $this->session->get('auth');

        $vars = [
            'page' => [
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $this->context, 's']),
                    'name' => implode('', [$this->context, 's']),
                    'Name' => ucwords(implode('', [$this->context, 's']))
                ]
            ],
            'user' => $user
        ];

        return $this->twig->render($response, '/workshop/fragments/create/note.html', $vars);
    }

    /**
     * Attempts to create a Note with the provided data.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        if($this->session->exists('validationErrors'))
        {
            $this->session->delete('validationErrors');
        }

        $body = $request->getParsedBody();

        $note = [
            'title' => $body['note_title'],
            'content' => $body['note_content'],
            'ticket' => $body['note_ticket'],
            'author' => $body['note_author']
        ];

        $validatorRules = [
            'required' => [
                'note.title',
                'note.content',
                'note.ticket',
                'note.author'
            ]
        ];

        $v = new Validator([
            'note' => $note
        ]);

        $v->rules($validatorRules);

        if(!$v->validate())
        {
            $this->session->store('validationErrors', $v->errors());

            return $response->withStatus(400);
        }

        $ticket = $this->tickets->getByUuid($note['ticket']);
        $author = $this->users->getByUuid($note['author']);

        $this->notes->create(
            $note['title'],
            $note['content'],
            $ticket,
            $author
        );

        return $response->withHeader('HX-Refresh', 'true')->withStatus(200);
    }

    /**
     * Deletes a given Note if it exists.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * 
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $note = $this->notes->getSingle($args['id']);

        if($note == null)
        {
            return $response->withStatus(400);
        }

        $this->notes->delete($note);

        return $response->withHeader('HX-Refresh', 'true')->withStatus(200);
    }
}