## Install project

Create file .env from .env.dist

```bash
make install
```

Web url http://localhost:8102/graphiql

Example query

```qraphql
query test1 {
  book(id: 2) {
    id,
    description,
    publicAt,
    name,
    authors {
      id,
      fullName
    }
  }
}

query test2 {
  books {
  	id,
    description,
    publicAt
  }
}
mutation test3 {
  createBook(name: "test name", description: "test", publicAt: "2020-01-01 00:00:00") {
    id,
    name,
    description
  }
}

mutation test4 {
  createBook(name: "test name", description: "test", publicAt: "2020-01-01 00:00:00", authors: [2]) {
    id,
    name,
    description,
    authors {
      id,
      fullName,
      quantityBooks
    }
  }
}

mutation test5 {
  updateBook(id: 1, name: "test name", description: "testfsdf1231", publicAt: "2020-01-01 00:00:00", authors: [4, 8]) {
    id,
    name,
    description,
    authors {
      id,
      fullName,
      quantityBooks
    }
  }
}

mutation test6 {
  deleteBook(id: 4) {
    id
  }
}

query test7 {
  author(id: 1) {
    id,
    fullName,
    createdAt,
    quantityBooks
  }
}

query test8 {
  author(id: 1) {
    id,
    fullName,
    createdAt,
    quantityBooks
  }
}

mutation test9 {
  createAuthor(fullName: "test name") {
    id,
    fullName,
    createdAt,
    quantityBooks
  }
}

mutation test10 {
  updateAuthor(id: 4, fullName: "test name") {
    id,
    fullName,
    createdAt,
    quantityBooks
  }
}

mutation test11 {
  deleteAuthor(id: 7) {
		id
  }
}
```
