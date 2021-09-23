Demo PostgreSQL Queue
==========

A demonstration of using PostgreSQL for a queueing service based on
[this online post](https://blog.crunchydata.com/blog/message-queuing-using-native-postgresql).

## How To Run

Install Docker and docker-compose if you haven't already.

Create your `.env` file:
```bash
mv .env.example .env
```

Build the image with:

```bash
docker-compose build
```

Run it:

```bash
docker-compose up
```

Enter the app with:

```bash
docker-exec -it app /bin/bash
```

Create tasks by running:

```bash
php scripts/create-task.php
```

Run tasks by either running:

```bash
php scripts/run-tasks-unsuccessfully.php
```

```bash
php scripts/run-tasks-successfully.php
```

Note: If you press `ctrl` - `c` mid-way through trying to run the tasks successfully, you will notice that the tasks are left in the queue and available for another "worker" to execute them.

Have a play and try to break it by running multiple shells each grabbing or fetching tasks at the same time. You won't be able to have two "workers" grab the same tasks, and if anything goes wrong whilst "working" on a task, the tasks are fetched by the next worker.
