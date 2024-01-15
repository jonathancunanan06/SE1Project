<?php

use Model\Entity\RegisteredEvent;
use Model\Repository\RegisteredEventRepositoryImpl;
use Model\Source\DatabaseMock;
use PHPUnit\Framework\TestCase;

class RegisteredRegisteredEventRepositoryImplTest extends TestCase {
    private ?DatabaseMock $database = null;

    public function test_When_AccessingNotExistingRegisteredEvent_Expect_ReturnNull() {
        $repository = new RegisteredEventRepositoryImpl($this->database->db);
        $registeredEvent = $repository->getRegisteredEvent("not existing registered event id");

        $this->assertNull($registeredEvent);
    }

    public function test_When_AddingNewRegisteredEvent_Expect_ReturnNewRegisterdEventId() {
        $repository = new RegisteredEventRepositoryImpl($this->database->db);
        $regEvent = new RegisteredEvent("temp id", "event id", "session id", null);

        $regEventId = $repository->addRegisterEvent($regEvent);

        $this->assertNotSame($regEvent->eventId, $regEventId);
    }

    public function test_When_AddingNewRegisteredEvent_Expect_AddedRegisteredEventToHaveSameValues() {
        $repository = new RegisteredEventRepositoryImpl($this->database->db);
        $regEvent = new RegisteredEvent("temp id", "event id", "session id", null);

        $regEventId = $repository->addRegisterEvent($regEvent);
        $addedRegEvent = $repository->getRegisteredEvent($regEventId);

        $this->assertSame($regEventId, $addedRegEvent->registeredEventId);
        $this->assertSame($regEvent->eventId, $addedRegEvent->eventId);
        $this->assertSame($regEvent->sessionId, $addedRegEvent->sessionId);
        $this->assertSame($regEvent->userId, $addedRegEvent->userId);
    }

    public function test_When_GettingRegisteredEventByUserWithNoEvent_Expect_EmptyResult() {
        $repository = new RegisteredEventRepositoryImpl($this->database->db);
        $regEvent = new RegisteredEvent("temp id", "event id", "session id", null);
        $repository->addRegisterEvent($regEvent);

        $events = $repository->getRegisteredEventsOfUser("user id with no registerd events");
        $this->assertEmpty($events);
    }

    public function test_When_GettingRegisteredEventByUser_Expect_CountOfResultToEqualNumberOfRegisteredEvent() {
        $repository = new RegisteredEventRepositoryImpl($this->database->db);
        $userId = "creatorId";
        $regEvent = new RegisteredEvent("temp id", "event id", "session id", $userId);

        $repository->addRegisterEvent($regEvent);
        $repository->addRegisterEvent($regEvent);
        $repository->addRegisterEvent($regEvent);

        $events = $repository->getRegisteredEventsOfUser($userId);
        $this->assertCount(3, $events);
    }

    protected function setUp() {
        $database = new DatabaseMock();
    }

    protected function tearDown() {
        $database = null;
    }
}