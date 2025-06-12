<?php

class Event {
    public int $id;
    public string $title;
    public string $description;
    public string $date_event;
    public string $date_end;
    public int $created_by;
    public bool $started;
    public ?string $img;
    public ?string $organizer = null;
    public ?int $participant_count = 0;
    public ?string $created_at = null; 
}
