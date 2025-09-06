// Mock data pour le système de forums et chat

export const mockForumCategories = [
  {
    id: 1,
    name: 'Annonces générales',
    description: 'Annonces importantes de la plateforme',
    type: 'announcements' as const,
    color: '#3B82F6',
    discussionCount: 12,
    messageCount: 45,
    lastMessage: {
      id: 1,
      content: 'Nouvelle mise à jour disponible',
      createdAt: new Date('2024-01-15T10:30:00Z'),
      author: {
        id: 1,
        name: 'Admin Système',
        avatar: 'https://i.pravatar.cc/150?img=1'
      }
    }
  },
  {
    id: 2,
    name: 'Support technique',
    description: 'Questions et problèmes techniques',
    type: 'technical' as const,
    color: '#EF4444',
    discussionCount: 28,
    messageCount: 156,
    lastMessage: {
      id: 2,
      content: 'Problème de connexion résolu',
      createdAt: new Date('2024-01-15T09:15:00Z'),
      author: {
        id: 2,
        name: 'Support Tech',
        avatar: 'https://i.pravatar.cc/150?img=2'
      }
    }
  },
  {
    id: 3,
    name: 'Discussions générales',
    description: 'Discussions libres entre apprenants',
    type: 'general' as const,
    color: '#10B981',
    discussionCount: 67,
    messageCount: 234,
    lastMessage: {
      id: 3,
      content: 'Excellente formation sur React !',
      createdAt: new Date('2024-01-15T08:45:00Z'),
      author: {
        id: 3,
        name: 'Marie Dubois',
        avatar: 'https://i.pravatar.cc/150?img=3'
      }
    }
  }
];

export const mockDiscussions = [
  {
    id: 1,
    title: 'Comment bien démarrer avec Laravel ?',
    content: 'Je débute avec Laravel et j\'aimerais avoir vos conseils...',
    status: 'open' as const,
    isPinned: false,
    categoryId: 3,
    authorId: 4,
    author: {
      id: 4,
      name: 'Pierre Martin',
      avatar: 'https://i.pravatar.cc/150?img=4',
      role: 'apprenant' as const
    },
    createdAt: new Date('2024-01-14T14:20:00Z'),
    updatedAt: new Date('2024-01-15T09:30:00Z'),
    viewCount: 45,
    replyCount: 8,
    likeCount: 12,
    lastReply: {
      id: 15,
      content: 'Je recommande de commencer par la documentation officielle',
      createdAt: new Date('2024-01-15T09:30:00Z'),
      author: {
        id: 5,
        name: 'Sophie Leroy',
        avatar: 'https://i.pravatar.cc/150?img=5'
      }
    }
  },
  {
    id: 2,
    title: 'Problème avec les sessions live',
    content: 'Je n\'arrive pas à rejoindre les sessions en direct...',
    status: 'resolved' as const,
    isPinned: false,
    categoryId: 2,
    authorId: 6,
    author: {
      id: 6,
      name: 'Thomas Durand',
      avatar: 'https://i.pravatar.cc/150?img=6',
      role: 'apprenant' as const
    },
    createdAt: new Date('2024-01-13T16:45:00Z'),
    updatedAt: new Date('2024-01-14T10:15:00Z'),
    viewCount: 23,
    replyCount: 5,
    likeCount: 3,
    lastReply: {
      id: 12,
      content: 'Problème résolu, merci pour votre aide !',
      createdAt: new Date('2024-01-14T10:15:00Z'),
      author: {
        id: 6,
        name: 'Thomas Durand',
        avatar: 'https://i.pravatar.cc/150?img=6'
      }
    }
  }
];

export const mockChatMessages = [
  {
    id: 1,
    content: 'Bonjour tout le monde !',
    type: 'global' as const,
    authorId: 3,
    author: {
      id: 3,
      name: 'Marie Dubois',
      avatar: 'https://i.pravatar.cc/150?img=3',
      isOnline: true
    },
    createdAt: new Date('2024-01-15T10:00:00Z'),
    isRead: true
  },
  {
    id: 2,
    content: 'Salut Marie ! Comment ça va ?',
    type: 'global' as const,
    authorId: 4,
    author: {
      id: 4,
      name: 'Pierre Martin',
      avatar: 'https://i.pravatar.cc/150?img=4',
      isOnline: true
    },
    createdAt: new Date('2024-01-15T10:02:00Z'),
    isRead: true
  },
  {
    id: 3,
    content: 'Est-ce que quelqu\'un peut m\'aider avec l\'exercice 3 ?',
    type: 'global' as const,
    authorId: 6,
    author: {
      id: 6,
      name: 'Thomas Durand',
      avatar: 'https://i.pravatar.cc/150?img=6',
      isOnline: false,
      lastSeen: new Date('2024-01-15T09:45:00Z')
    },
    createdAt: new Date('2024-01-15T10:05:00Z'),
    isRead: false
  }
];

export const mockOnlineUsers = [
  {
    id: 3,
    name: 'Marie Dubois',
    avatar: 'https://i.pravatar.cc/150?img=3',
    role: 'apprenant' as const,
    isOnline: true,
    lastSeen: new Date()
  },
  {
    id: 4,
    name: 'Pierre Martin',
    avatar: 'https://i.pravatar.cc/150?img=4',
    role: 'apprenant' as const,
    isOnline: true,
    lastSeen: new Date()
  },
  {
    id: 7,
    name: 'Prof. Leclerc',
    avatar: 'https://i.pravatar.cc/150?img=7',
    role: 'formateur' as const,
    isOnline: true,
    lastSeen: new Date()
  }
];