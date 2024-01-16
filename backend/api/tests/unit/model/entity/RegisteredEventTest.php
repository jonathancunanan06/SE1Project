<?php


namespace Model\Entity {
    function http_response_code(int $code = 0) : int|bool {
        static $currentCode = 200;
        $temp = $currentCode;

        if ($code !== 0) $currentCode = $code;
        return $temp;
    }

}

namespace {

    use Model\Entity\RegisteredEvent;
    use PHPUnit\Framework\TestCase;

    class RegisteredEventTest extends TestCase {
        public function test_When_RegisteredEventIsNotNull_Expect_OutputJson() : void {
            $registeredEvent = new RegisteredEvent("registeredEventId", "event id", "session id","registeredName", "user id");

            RegisteredEvent::respond($registeredEvent);
            $output = json_decode($this->getActualOutputForAssertion());
            $this->assertSame($registeredEvent->registeredEventId, $output->registeredEventId);
            $this->assertSame($registeredEvent->eventId, $output->eventId);
            $this->assertSame($registeredEvent->sessionId, $output->sessionId);
            $this->assertSame($registeredEvent->userId, $output->userId);
        }

        public function test_When_EventIsNull_Expect_ResponseCodeToBe404() : void { 
            RegisteredEvent::respond(null);
            $this->assertSame(404, Model\Entity\http_response_code());
        }
    }
}