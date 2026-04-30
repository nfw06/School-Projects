#include <iostream>

#include "include/functions.hpp"
#include "include/display.hpp"  

// To Compile and Run: g++ main.cpp src/display.cpp src/functions.cpp -std=c++17 -O2 -o main.exe && .\main.exe

int main() {
  std::array<int, 8> blocco {1, 0, 1, 1, 0, 0, 1, 0};

  std::cout << "Blocco Iniziale: ";
  print_blocco(blocco);

  std::array<int, 8> result_sbox = convert_to_sbox(blocco);

  std::cout << "Blocco Converted: ";
  print_blocco(result_sbox);
  std::cout << '\n';

  return 0;
}