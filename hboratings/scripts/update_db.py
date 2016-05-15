from hboratings.movies.models import Movie
from hboratings.movies.serializers import MovieSerializer
from hboratings.movies.services import HBOService

def run():

    movies = HBOService.get_movie_elements()

    movie_objects = []
    for movie in movies:
        serializer = MovieSerializer(data=movie)

        if serializer.is_valid():
            obj = serializer.save()
            movie_objects.append(obj)

    print movie_objects
