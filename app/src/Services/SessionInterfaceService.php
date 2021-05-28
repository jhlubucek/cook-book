<?php
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionInterfaceService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function set()
    {
        $this->session->set('attribute-name', 'attribute-value');

        // gets an attribute by name
        $foo = $this->session->get('foo');

        // the second argument is the value returned when the attribute doesn't exist
        $filters = $this->session->get('filters', []);

        // ...
    }
}