-- SQLite
select
    r.id,
    r.email,
    r.name,
    r.event,
    r.ticket/* ,
    count(*) as qtd */
from
    (select
        people.email as email,
        people.id as id,
        people.name as name,
        events.name as event,
        people_event.ticket_type as ticket
    from
        people_event,
        events,
        people
    where
        people_event.people_id = people.id AND
        people_event.event_id = events.id
    group by
        people.email, events.name) as r
/* group by
    r.email
order by
    qtd desc */
