<?php

namespace Model\Entity;

/**
 * @property string $registeredEventId id of the registered event
 * @property string $eventId id of the event registered
 * @property string $sessionId id of the session used to create Event
 * @property ?string $userId id of the user that registered, may be null
 */
class RegisteredEvent {
    public string $registeredEventId;
    public string $eventId;
    public string $sessionId;
    public ?string $userId;

    public function __construct(string $registeredEventId, string $eventId, string $sessionId, ?string $userId) {
        $this->registeredEventId = $registeredEventId;
        $this->eventId = $eventId;
        $this->sessionId = $sessionId;
        $this->userId = $userId;
    }

    /**
     * Function to send a JSON representation of registered event as response
     * error code is 404 if $registeredEvent is null, otherwise 200
     * 
     * @param ?RegisteredEvent 
     */
    public static function respond(?RegisteredEvent $registeredEvent) {
        if ($registeredEvent === null) {
            http_response_code(404);
            echo json_encode(['error' => 'Registered event not found'], JSON_PRETTY_PRINT);
        } else {
            http_response_code(200);
            echo json_encode([
                'registeredEventId' => $registeredEvent->registeredEventId,
                'eventId' => $registeredEvent->eventId,
                'sessionId' => $registeredEvent->sessionId,
                'userId' => $registeredEvent->userId,
            ]);
        }
    }
}
