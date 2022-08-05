## Events

If you think about events, they have a few key properties:

- start (and end time) / duration
- location
- title
- description

- attendance mode (mixed, offline, online)
- price information (optional, maps to a PriceInformation table)
  - is free?
  - price information
  - additional text 
- 

### Content


### Super event
An event that this event is a part of. 
For example, a collection of individual music performances might each have a music festival as their superEvent.
(from schema.org)

### Ticket / price information
Each event maps to a `PriceInformation` object in the database.
This makes it possible to only enter the price information once even for consecutive events. 

#### Price Information
- id
- uuid
- label (optional)
- is_free (boolean)
- 



We build an overview over events and therefore categorize them into the following categories:

### Events today
This category contains events that are currently happening.

### Featured events
This category contains events that are currently featured.
Featured events are presented with a big picture.


- **events today**
- **long-term events**

- long term event
