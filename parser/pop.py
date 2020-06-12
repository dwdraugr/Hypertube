from popcorntimeapi.Popcorn import PopcornTimeApi

popcorn = PopcornTimeApi()

random_movie = popcorn.get_random()

print(random_movie.title)
