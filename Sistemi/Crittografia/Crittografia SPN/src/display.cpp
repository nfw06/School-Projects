#include "../include/display.hpp"

void print_blocco(const std::array<int, 8>& blocco) {
  for (int i = 0; i < blocco.size(); i++) {
    std::cout << blocco[i];
  }
  std::cout << '\n';
}