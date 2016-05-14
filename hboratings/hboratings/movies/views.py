from rest_framework.generics import GenericAPIView
from rest_framework.response import Response
from .models import Movie
from .serializers import MovieSerializer

# class SuccessResponse(Response):

#     "Constructor, takes data and puts in the correct field"
#     def __init__(self, data, status):
#         data = data
#         super(SuccessResponse, self).__init__(data, status=status)

# class ErrorResponse(Response):

#     "Constructor, takes data and puts in the correct field"
#     def __init__(self, error, status):
#         data = {
#             "error": error
#         }
#         super(ErrorResponse, self).__init__(data, status=status)

class MovieView(GenericAPIView):

    def get(self, request):
        movies = Movie.objects.all()

        self.serializer = MovieSerializer(movies, many=True)

        return Response(self.serializer.data, status=200)