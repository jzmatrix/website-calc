// main.go

package main

//"net/http"

//"github.com/gorilla/mux"

/*
func main() {
	if err := godotenv.Load(); err != nil {
		log.Fatalf("Failed to load the env vars: %v", err)
	}

	auth, err := authenticator.New()
	if err != nil {
		log.Fatalf("Failed to initialize the authenticator: %v", err)
	}

	rtr := router.New(auth)

	log.Print("Server listening on http://localhost:80/")
	if err := http.ListenAndServe("0.0.0.0:80", rtr); err != nil {
		log.Fatalf("There was an error with the http server: %v", err)
	}
}
*/
func main() {
	localHandlers.initHandlers()
	// fmt.Println(initHandlers())
	/*

		// Declare a new router
		r := mux.NewRouter()

		// This is where the router is useful, it allows us to declare methods that
		// this path will be vaild for
		r.HandleFunc("/", roothandler.rootHandler).Methods("GET")
		// r.HandleFunc("/GET", getStatus).Methods("GET")
		// r.HandleFunc("/GET/", getStatus).Methods("GET")
		// r.HandleFunc("/SET", setStatus).Methods("GET")
		// r.HandleFunc("/SET/", setStatus).Methods("GET")
		// r.HandleFunc("/SET", doSetStatus).Methods("POST")

		// We can then pass our router (after declaring all our routes) to this method
		// (where previously, we were leaving the second argument as nil)
		http.ListenAndServe(":80", r)
	*/
}
